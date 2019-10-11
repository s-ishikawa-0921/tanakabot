# -*- coding: utf-8 -*-

import os, sys
import re
from functools import partial
import codecs
import json

try:
    unicode
    import codecs
    sys.stdout = codecs.getwriter('utf-8')(sys.stdout)
    def copen(fname, mode):
        return codecs.open(fname, mode, "utf-8")
except:
    def copen(fname, mode):
        return open(fname, mode, encoding='utf-8')

nuc_dir = "data/FacebookMessenger"

fix_mojibake_escapes = partial(
    re.compile(rb'\\u00([\da-f]{2})').sub,
    lambda m: bytes.fromhex(m.group(1).decode()))

def make_sequence_from_messenger_file(dir):

    fname = os.path.join(nuc_dir, dir, "message_1.json")
    if not os.path.exists(fname):
        raise Exception("no %s file." % fname)
    last_line = None
    sequence = []
    
    with open(fname, "r", newline='', encoding='utf-8') as f:

        # ファイル読み込み
        with open(fname, 'rb') as binary_data:
            repaired = fix_mojibake_escapes(binary_data.read())

            try:
                data = json.loads(repaired.decode('utf8'))
            except:
                print("file: %s\n" % (fname))
                return sequence


        seq_prev = ""
        prevTanaka = False
        

        if not {"name" : "田中 涼太"} in data['participants']:
            return sequence


        # 投稿毎に分割（投稿はCRLF区切り、投稿内容はタブ区切りになっている）
        for line in reversed(data['messages']):

            if not 'content' in line:
                continue

            #sys.stderr.write("%s : %s\n" % (line['sender_name'], line['content']))

            # 発言内容
            comment = line['content']

            # 不要な改行やクォーテーションを削除
            comment = re.sub("\n"," ",comment)
            comment = re.sub("  "," ",comment)
            comment = comment.lstrip("\"")
            comment = comment.rstrip("\"")

            # 写真やスタンプは除外
            # if comment.startswith(("[写真]","[スタンプ]", "[動画]", "[ノート]", "[アルバム]", "[連絡先]", "[ボイスメッセージ]", "[投票]")):
            #     continue
            
            if line['sender_name'] != "田中 涼太":
                seq_prev = comment
                prevTanaka = False
            else:
                # 誰かの発言に対して田中涼太が発言している組み合わせを記録
                if seq_prev != "":

                    if not prevTanaka:
                        sequence.append([seq_prev, comment])
                    else:
                        sequence[-1][1] = sequence[-1][1] + ' ' + comment
                    #sys.stderr.write("input[%s] : 田中涼太[%s]\n" % (seq_prev, items[2]))
                    #seq_prev = ""
                
                prevTanaka = True
    return sequence

def main():
    
    if not os.path.exists(nuc_dir):
        raise Exception("no extracted files.")

    dirs = os.listdir(nuc_dir)
    uniq_seq = {}

    with open("sequenceFb.txt", "w", encoding='utf-8') as f_out:

        for dir in dirs:
            seq = make_sequence_from_messenger_file(dir)
            # for inp, out in seq:
            #     uniq_seq[inp] = out
        
            for inp, out in seq:
                f_out.write("input: %s\n" % (inp))
                f_out.write("output: %s\n" % (out))
        # for k, v in uniq_seq.items():
        #     f_out.write("input: %s\n" % (k))
        #     f_out.write("output: %s\n" % (v))
            #print("input: %s\noutput: %s" % (k, v))
    
    # with open("sequenceT.txt", "w", encoding='utf-8') as f_out:

    #     for f in files:
    #         if not ".txt" in f:
    #             continue
    #         seq = make_sequence_from_file(f)

    #         for inp, out in seq:
    #             f_out.write("%s\t%s\n" % (inp, out))

    # with open("sequenceN.txt", "w", encoding='utf-8') as f_out:

    #     for f in files:
    #         if not ".txt" in f:
    #             continue
    #         seq = make_sequence_from_file(f)

    #         for inp, out in seq:
    #             f_out.write("%s\n%s\n\n" % (inp, out))
    return


if __name__ == "__main__":
    main()
    sys.exit(0)
#
